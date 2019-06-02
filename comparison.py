#! python

import numpy as np
import os
from os import listdir
from os.path import isfile, join
import skimage
from skimage import exposure
from skimage import feature
import cv2
import pymysql
import math
conn = pymysql.connect(host='localhost', user='root', password='', db='Primerjalko')
db = conn.cursor()

class LocalBinaryPatterns:
    def __init__(self, numPoints, radius):
        self.numPoints = numPoints
        self.radius = radius

    def describe(self, image, eps=1e-7):
        lbp = feature.local_binary_pattern(image, self.numPoints,
                                           self.radius, method="uniform")
        (hist, _) = np.histogram(lbp.ravel(), bins=np.arange(0, 256), range=(0, 256))
        hist = hist.astype("float")
        cv2.normalize(hist, hist, alpha=0, beta=1, norm_type=cv2.NORM_MINMAX)
        return hist


my_path = os.path.abspath(os.path.dirname(__file__))
path = os.path.join(my_path, "/saveImgToLocal/")
path = my_path + '\saveImgToLocal\\'
onlyfiles = [f for f in listdir(path) if isfile(join(path, f))]

desc = LocalBinaryPatterns(253, 8)
data = []  # LBP histogram
labels = []  # imena datotek
HOGs = []  # HOG vrednosti
for imagePath in onlyfiles:
    ext = imagePath.split(".")
    if ext[1] == "jpg" or ext[1] == "png" or ext[1] == "bmp" or ext[1] == "jpeg" or ext[1] == "JPG":
        image = cv2.imread(path + imagePath)
        image = np.float32(image)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        gray = np.float32(gray)
        hist = desc.describe(gray)
        H = feature.hog(image, orientations=9, pixels_per_cell=(8, 8), cells_per_block=(2, 2), transform_sqrt=True)
        HOGs.append(H)
        imgName = imagePath.split(".")
        labels.append(imgName[0])
        data.append(hist)
    else:
        continue

i = 0
j = 1
while i < len(data):
    ime = labels[i]
    set = data[i]
    hog1 = HOGs[i]
    while j < len(data):
        ime2 = labels[j]
        set2 = data[j]
        hog2 = HOGs[j]
        eqRate = cv2.compareHist(np.float32(set), np.float32(set2), cv2.HISTCMP_BHATTACHARYYA)
        if eqRate < 0.15:
            sql = "INSERT INTO similarproducts(Text, Products_ID, SimilarProduct_ID) VALUES ((%d), (%s), (%s))"%(eqRate, ime, ime2)
            retVal = db.execute(sql)
            conn.commit()
            if retVal != 1:
                print("Failed Insert")
            else:
                print("Sucess")
        else:
            print("not enough similiarity")
        k=0
        suma=0
        while k < len(hog1):
            loc = hog2[k]-hog1[k]
            loc = pow(loc, 2)
            suma = suma + math.sqrt(loc)
            k=k+1
        if suma < 120:
            sql = "INSERT INTO similarproducts(Description, Products_ID, SimilarProduct_ID) VALUES ((%d), (%s), (%s))" % (
            suma, ime, ime2)
            retVal = db.execute(sql)
            conn.commit()
            if retVal != 1:
                print("Failed Insert")
            else:
                print("Sucess")
        else:
            print("HOGs are too far apart")
        j = j + 1
    i = i + 1
conn.close()
