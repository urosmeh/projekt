import numpy as np
import os
from os import listdir
from os.path import isfile, join
import skimage
from skimage import exposure
from skimage import feature
import cv2


class LocalBinaryPatterns:
    def __init__(self, numPoints, radius):
        self.numPoints = numPoints
        self.radius = radius

    def describe(self, image, eps=1e-7):
        lbp = feature.local_binary_pattern(image, self.numPoints,
                                           self.radius, method="uniform")
        (hist, _) = np.histogram(lbp.ravel(),bins=np.arange(0, 256),range=(0, 256))

        hist = hist.astype("float")
        #hist /= (hist.sum() + eps)
        cv2.normalize(hist, hist, alpha=0, beta=1, norm_type=cv2.NORM_MINMAX)
        return hist






onlyfiles = [f for f in listdir("./SaveImgToLocal/") if isfile(join("./SaveImgToLocal/", f))]
print(onlyfiles)

desc = LocalBinaryPatterns(253, 8)
data = [] #LBP histogram
labels = [] #imena datotek
HOGs = [] #HOG vrednosti
for imagePath in onlyfiles:
    ext=imagePath.split(".")
    if(ext[1] == "jpg" or ext[1] == "png" or ext[1] == "bmp" or ext[1] == "jpeg" or ext[1] == "JPG"):
        print("./SaveImgToLocal/" + imagePath)
        image = cv2.imread("./SaveImgToLocal/" + imagePath)
        image = np.float32(image)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        gray = np.float32(gray)
        hist = desc.describe(gray)
        H = feature.hog(image, orientations=9, pixels_per_cell=(8, 8), cells_per_block=(2, 2), transform_sqrt=True)
        HOGs.append(H)
        labels.append(imagePath)
        data.append(hist)
    else:
        continue

prviDrugi = cv2.compareHist(np.float32(data[0]), np.float32(data[1]), cv2.HISTCMP_BHATTACHARYYA)
print(prviDrugi)

i = 0
j = 0
size = len(data)
lenOfitem = len(data[0])
print(lenOfitem)
lenOfitem=len(data[1])
print(lenOfitem)

input('Press ENTER to exit')