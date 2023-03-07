import requests
import json

url = 'https://www.googleapis.com/books/v1/volumes?q='

response = requests.get(url + 'best selling')


json_data = json.loads(response.text)


book_data = []
for item in json_data['items']
        book = {}
        book['title'] = item['volumeInfo']['title']
        book['author'] = item['volumeInfo']['authors']
        book['description'] = item['volumeInfo']['description']
        book['published_date'] = item['volumeInfo']['publishedDate']
        book['page_count'] = item['volumeInfo']['pageCount']
        book_data.append(book)


print(book_data)
