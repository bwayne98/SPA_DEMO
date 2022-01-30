import requests
from bs4 import BeautifulSoup

req = requests.get('http://je.joy.com.tw/01_Joy_News.php')
web = BeautifulSoup(req.text,'html5lib')



print(web)