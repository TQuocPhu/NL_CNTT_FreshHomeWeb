from fastapi import FastAPI, UploadFile, File
import torch
from torchvision import models, transforms
from PIL import Image
import io
import requests
from labels_vn import TRANSLATIONS

app = FastAPI()

# 1. Tối ưu: Load model một lần duy nhất khi khởi chạy
device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
model = models.mobilenet_v3_small(weights=models.MobileNet_V3_Small_Weights.IMAGENET1K_V1)
model.to(device)
model.eval()

# 2. Tối ưu: Tải labels và chuyển về dạng dictionary để tra cứu nhanh hơn
try:
    LABELS_URL = "https://raw.githubusercontent.com/pytorch/hub/master/imagenet_classes.txt"
    labels_en = requests.get(LABELS_URL).text.splitlines()
except:
    labels_en = [] # Backup nếu mất mạng

# Tiền xử lý cố định
preprocess = transforms.Compose([
    transforms.Resize(256),
    transforms.CenterCrop(224),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225]),
])

def get_prediction(image_bytes):
    image = Image.open(io.BytesIO(image_bytes)).convert('RGB')
    tensor = preprocess(image).unsqueeze(0).to(device)

    with torch.no_grad():
        outputs = model(tensor)
        probs, indices = torch.topk(outputs, 5) # Lấy top 5
    
    top5_labels = [labels_en[idx].lower() for idx in indices[0]]

    
    # 4. Mapping thông minh
    for label_en in top5_labels:
        # Chuẩn hóa nhãn AI (thay _ bằng khoảng trắng để dễ khớp)
        clean_label = label_en.replace('_', ' ')
        
        # Duyệt qua TRANSLATIONS
        for key, vn_name in TRANSLATIONS.items():
            # So khớp 2 chiều: key trong label hoặc ngược lại
            key_clean = key.replace('_', ' ')
            if key_clean in clean_label or clean_label in key_clean:
                return vn_name

    # Nếu không khớp bất cứ thứ gì trong 1000 lớp VN, trả về nhãn tiếng Anh tin cậy nhất
    return top5_labels[0].replace('_', ' ')

@app.post("/predict")
async def predict(file: UploadFile = File(...)):
    try:
        # Tối ưu: Kiểm tra định dạng file
        if not file.content_type.startswith('image/'):
            return {"error": "File không phải là hình ảnh"}
            
        contents = await file.read()
        keyword = get_prediction(contents)
        
        return {"keyword": keyword}
    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8001)