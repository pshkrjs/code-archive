import sys
import cv2
import numpy as np

ip_file = sys.argv[1]
img = cv2.imread(ip_file,0)
flag = 0

for i in range(1,6):
    if i == 1:
        site = 'google'
    elif i == 2:
        site = 'facebook'
    elif i == 3:
        site = 'wikipedia'
    elif i == 4:
        site = 'quora'
    elif i == 5:
        site = 'reddit'
    template = cv2.imread(site+'_logo.png',0)
    w, h = template.shape[::-1]
    res = cv2.matchTemplate(img,template,eval('cv2.TM_CCOEFF_NORMED'))
    min_val, max_val, min_loc, max_loc = cv2.minMaxLoc(res)

    if max_val > 0.95:
        print "Website is http://"+site+".com"
        flag = 1
        break;

if flag == 0:
    print "None of known websites"