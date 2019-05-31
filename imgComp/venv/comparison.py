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






onlyfiles = [f for f in listdir("./img/") if isfile(join("./img", f))]
print(onlyfiles)

desc = LocalBinaryPatterns(253, 8)
data = [] #LBP histogram
labels = [] #imena datotek
HOGs = [] #HOG vrednosti
for imagePath in onlyfiles:
    print("./img/"+imagePath)
    image = cv2.imread("./img/"+imagePath)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    hist = desc.describe(gray)
    H = feature.hog(image, orientations=9, pixels_per_cell=(8, 8), cells_per_block=(2, 2), transform_sqrt=True)
    HOGs.append(H)
    labels.append(imagePath)
    data.append(hist)


i = 0
j = 0
size = len(data)
lenOfitem = len(data[0])
print(lenOfitem)
lenOfitem=len(data[1])
print(lenOfitem)

input('Press ENTER to exit')