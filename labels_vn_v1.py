# labels_vn.py
# ==================================================
# Labels tối ưu cho CLIP zero-shot (độ chính xác cao)
# ==================================================

# ---------- FRUITS ----------
FRUITS = {
    "fresh ripe banana": "Chuối",
    "banana bunch": "Chuối",
    "peeled banana": "Chuối",

    "fresh red apple": "Táo",
    "whole apple fruit": "Táo",

    "fresh ripe mango": "Xoài",
    "sliced mango fruit": "Xoài",

    "whole papaya fruit": "Đu đủ",
    "cut papaya fruit": "Đu đủ",

    "fresh orange citrus fruit": "Cam",

    "whole pineapple fruit": "Dứa",
    "pineapple slices": "Dứa",

    "whole watermelon": "Dưa hấu",
    "watermelon slice": "Dưa hấu",

    "whole avocado fruit": "Bơ",
    "cut avocado half": "Bơ",
}

# ---------- VEGETABLES ----------
VEGETABLES = {
    "whole pumpkin vegetable": "Bí đỏ",
    "cut pumpkin pieces": "Bí đỏ",

    "whole carrot vegetable": "Cà rốt",
    "sliced carrot": "Cà rốt",

    "fresh cucumber vegetable": "Dưa leo",
    "whole cucumber": "Dưa leo",

    "raw potato vegetable": "Khoai tây",

    "fresh tomato vegetable": "Cà chua",
    "tomato slices": "Cà chua",

    "whole onion vegetable": "Hành tây",
    "sliced onion": "Hành tây",

    "garlic bulbs": "Tỏi",
}

# ---------- MEATS ----------
MEATS = {
    "raw pork meat": "Thịt heo",
    "fresh pork meat": "Thịt heo",
    "pork belly raw": "Thịt ba chỉ",
    "minced pork meat": "Thịt heo xay",

    "raw beef meat": "Thịt bò",
    "fresh beef slices": "Thịt bò",

    "raw chicken meat": "Thịt gà",
    "whole raw chicken": "Thịt gà",

    "raw pork ribs": "Sườn heo",
}

# ---------- SEAFOODS ----------
SEAFOODS = {
    "whole raw fish": "Cá nguyên con",
    "fresh fish on ice": "Cá tươi",
    "fish fillet raw": "Phi lê cá",
    "fish steak cut": "Khúc cá",
    "fish slices raw": "Lát cá",
    "dried fish food": "Cá khô",

    "raw shrimp seafood": "Tôm",
    "raw prawn seafood": "Tôm lớn",

    "raw squid seafood": "Mực",
    "raw octopus seafood": "Bạch tuộc",
}

# ---------- GRAINS ----------
GRAINS = {
    "uncooked white rice grains": "Gạo trắng",
    "uncooked brown rice grains": "Gạo lứt",
    "sticky rice grains": "Gạo nếp",
    "rice grains close up": "Hạt gạo",
    "raw rice in bowl": "Gạo",
    "rice sack": "Bao gạo",
}

# ---------- PACKAGED ----------
PACKAGED = {
    "fish sauce bottle": "Nước mắm",
    "soy sauce bottle": "Nước tương",
    "salt package": "Muối",
    "sugar package": "Đường",
    "instant noodles package": "Mì gói",
    "packaged food product": "Thực phẩm đóng gói",
}

# ---------- NON FOOD ----------
NON_FOOD = {
    "plastic bag": "Không phải thực phẩm",
    "plastic packaging": "Không phải thực phẩm",
    "food container": "Không phải thực phẩm",
    "bottle container": "Không phải thực phẩm",
}

# ---------- GROUP MAP ----------
GROUPS = {
    "fruit": FRUITS,
    "vegetable": VEGETABLES,
    "meat": MEATS,
    "seafood": SEAFOODS,
    "grain": GRAINS,
    "packaged": PACKAGED,
    "non_food": NON_FOOD,
}
