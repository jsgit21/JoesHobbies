import sys
import xml.dom.minidom
import mysql.connector

document = xml.dom.minidom.parse(sys.argv[1])
id = sys.argv[2]
info = {}
info['id'] = id

flagchar = sys.argv[1][-7]

if flagchar == 'h':
    info['store'] = "hobbylobby"
    div = document.getElementsByTagName('div')
    for element in div:
        class_attribute = element.getAttribute('class')
        if class_attribute == 'section':
            d = element.getElementsByTagName('div')
            for e in d:
                name = e.getAttribute('data-name')
                if(name == ''):
                    continue
                info['title'] = name

    meta = document.getElementsByTagName('meta')
    for element in meta:
        prop = element.getAttribute('property')
        content = element.getAttribute('content')

        if prop == 'og:description':
            info['description'] = content
        elif prop == 'og:url':
            info['url'] = content
        elif prop == 'og:image':
            info['iurl'] = content


    span = document.getElementsByTagName('span')
    for element in span:
        itemprop = element.getAttribute('itemprop')
        if itemprop == 'ratingValue':
            for node in element.childNodes:
                if node.nodeType == node.TEXT_NODE:
                    info['rating'] = node.nodeValue[0:-6]
        elif itemprop == 'price':
            price = element.getAttribute('content')
            info['price'] = price
else:
    info['store'] = "michaels"
    meta = document.getElementsByTagName('meta')
    for element in meta:
        prop = element.getAttribute('property')
        content = element.getAttribute('content')
        
        if prop == 'og:title':
            info['title'] = content
        elif prop == 'og:description':
            info['description'] = content
        elif prop == 'og:price:amount':
            info['price'] = content
        elif prop == 'og:url':
            info['url'] = content
        elif prop == 'og:image':
            info['iurl'] = content

    span = document.getElementsByTagName('span')
    for element in span:
        class_attribute = element.getAttribute('class')
        if class_attribute == 'bvseo-ratingValue':
            for node in element.childNodes:
                if node.nodeType == node.TEXT_NODE:
                    info['rating'] = node.nodeValue

print("\n")
print("ID: "+str(info["id"]) + " from: " + str(info["store"]))
""" print("title: "+str(info["title"]))
print("desc: "+str(info["description"]))
print("price: "+str(info["price"]))
print("url: "+str(info["url"]))
print("iurl: "+str(info["iurl"]))
print("rating: "+str(info["rating"])) """

""" 
Products:
    -> id INT(10)
    -> title VARCHAR(255)
    -> description VARCHAR(500)
    -> price DECIMAL(6,2)
    -> url VARCHAR(500)
    -> iurl VARCHAR(500)
    -> rating VARCHAR(5)
    -> store VARCHAR(20)
"""
def insert(cursor, id, title, descr, price, url, iurl, rating, store):
    query = 'INSERT INTO products(id, title, description, price, url, iurl, rating, store) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)'
    cursor.execute(query, (id, title, descr, price, url, iurl, rating, store))

def update(cursor, id, title, descr, price, url, iurl, rating, store):
    query = 'UPDATE products SET title=%s, description=%s, price=%s, url=%s, iurl=%s, rating=%s WHERE id=%s AND store=%s'
    cursor.execute(query, (title, descr, price, url, iurl, rating, id, store))

try:
    cnx = mysql.connector.connect(host='localhost', user='root', password='Rightguard123', database='storeDB', auth_plugin='mysql_native_password')
    cursor = cnx.cursor()

    cursor.execute(
        "SELECT title FROM products WHERE id = %s AND store = %s",(info['id'], info['store'],)
    )
    results = cursor.fetchall()
    count = cursor.rowcount
    if count == 0:
        print("Record does not exist -- adding")
        insert(cursor, info['id'], info['title'], info['description'], info['price'], info['url'], info['iurl'], info['rating'], info['store'])
        cnx.commit()
    else:
        print("Record exists -- updating")
        update(cursor, info['id'], info['title'], info['description'], info['price'], info['url'], info['iurl'], info['rating'], info['store'])
        cnx.commit()

    cursor.close()
except mysql.connector.Error as err:
    print(err)
finally:
    try:
        cnx
    except NameError:
        pass
    else:
        cnx.close()