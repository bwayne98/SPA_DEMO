import requests
from bs4 import BeautifulSoup

def main():

    req = requests.get('http://je.joy.com.tw/01_Joy_News.php')
    web = BeautifulSoup(req.text,'html5lib')

    print(web)


if __name__ == "__main__":
    main()

print("test")