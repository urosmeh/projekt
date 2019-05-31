import numpy as np
import os
from os import listdir
from os.path import isfile, join
#from pyimagesearch.localbinarypatterns import LocalBinaryPatterns
import skimage
from skimage import exposure
from skimage import feature
import cv2

onlyfiles = [f for f in listdir("./img/") if isfile(join("./img", f))]
print(onlyfiles)

#desc = LocalBinaryPatterns(24, 8)
data = []
labels = []


for imagePath in onlyfiles:
    print("./img/"+imagePath)
    image = cv2.imread("./img/"+imagePath)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    #hist = desc.describe(gray)
    #H = feature.hog(imagePath, orientations=9, pixels_per_cell=(8, 8),cells_per_block=(2, 2), transform_sqrt=True,visualise=True)
    labels.append("./img/"+imagePath)
    #data.append(hist)

print(labels)