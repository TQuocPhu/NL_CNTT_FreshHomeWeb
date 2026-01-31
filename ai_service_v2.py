from fastapi import FastAPI, UploadFile, File
import torch
import clip
from PIL import Image
import io
import uvicorn

from labels_vn_v1 import GROUPS

# =========================
# APP
# =========================
app = FastAPI(title="FRESHHOME AI")

device = "cuda" if torch.cuda.is_available() else "cpu"
model, preprocess = clip.load("ViT-B/32", device=device)
model.eval()

GROUP_PROMPTS = {
    "fruit": "a photo of fruit",
    "vegetable": "a photo of vegetable",
    "meat": "a photo of raw meat",
    "seafood": "a photo of seafood",
    "grain": "a photo of rice grains",
    "packaged": "a photo of packaged food",
    "non_food": "a photo of non food object",
}

group_names = list(GROUP_PROMPTS.keys())
group_tokens = clip.tokenize(list(GROUP_PROMPTS.values())).to(device)

with torch.no_grad():
    group_features = model.encode_text(group_tokens)
    group_features /= group_features.norm(dim=-1, keepdim=True)

ITEM_FEATURES = {}

def build_prompts(label: str):
    return [
        f"a photo of {label}",
        f"a photo of fresh {label}",
        f"a photo of raw {label}",
        f"a close-up photo of {label}",
    ]

for group, items in GROUPS.items():
    prompts = []
    meta = []

    for label_en, label_vn in items.items():
        for p in build_prompts(label_en):
            prompts.append(p)
            meta.append(label_vn)

    tokens = clip.tokenize(prompts).to(device)

    with torch.no_grad():
        feats = model.encode_text(tokens)
        feats /= feats.norm(dim=-1, keepdim=True)

    ITEM_FEATURES[group] = {
        "features": feats,
        "meta": meta
    }

def predict_image(image_bytes: bytes):
    image = Image.open(io.BytesIO(image_bytes)).convert("RGB")
    image_input = preprocess(image).unsqueeze(0).to(device)

    with torch.no_grad():
        img_feat = model.encode_image(image_input)
        img_feat /= img_feat.norm(dim=-1, keepdim=True)

        # ---- GROUP STAGE ----
        group_sim = (img_feat @ group_features.T).squeeze(0)
        group_idx = group_sim.argmax().item()
        group = group_names[group_idx]

        # ---- ITEM STAGE ----
        data = ITEM_FEATURES[group]
        sim = (img_feat @ data["features"].T).squeeze(0)

        best_idx = sim.argmax().item()
        confidence = sim[best_idx].item()

    if confidence < 0.28 or group == "non_food":
        return {
            "group": "other",
            "keyword": "Thực phẩm khác",
            "confidence": round(confidence, 3)
        }

    return {
        "group": group,
        "keyword": data["meta"][best_idx],
        "confidence": round(confidence, 3)
    }

# =========================
# API
# =========================
@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    if not file.content_type.startswith("image/"):
        return {"error": "File không phải hình ảnh"}

    image_bytes = await file.read()
    return predict_image(image_bytes)

# =========================
# MAIN
# =========================
def main():
    uvicorn.run(
        "ai_service:app",
        host="127.0.0.1",
        port=8001,
        reload=False
    )

if __name__ == "__main__":
    main()
