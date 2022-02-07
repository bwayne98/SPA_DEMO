import json
import requests
from bs4 import BeautifulSoup

def main():

    req = requests.get('http://je.joy.com.tw/01_Joy_News.php')
    req.encoding = 'utf-8'
    soup = BeautifulSoup(req.text,'html5lib')

    articles = soup.select('div.year-line-style',limit=50)

    data = []

    for article in articles:
        temp = article.findChild('a')
        href = temp.get('href')
        date = href[12:16]+"-"+href[16:18]+"-"+href[18:20]
        data.append([date,"http://je.joy.com.tw/" + href, article.text.strip()])
        # print(date)
        # print("http://je.joy.com.tw/" + href)
        # print(article.text.strip())   

    print(json.dumps(data))

if __name__ == "__main__":
    main()