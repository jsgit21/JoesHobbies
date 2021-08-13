# JoesHobbies

This project was completed for an NJIT course<br>
CS288 Intensive Programming in Linux - https://web.njit.edu/~sohna/cs288/ (Not exact professor)<br>
This final project utilized LAMP (Linux, Apache, MySQL, PHP)

For this project, I had to find two online stores that I could take 25 items from each. For each item from one store, I had to find a "similar" competing item from the other store essentially giving me 50 individual items but 25 pairs. With this information I was tasked with creating a "drop-shipping" website, where all the items would be listed. Once a user chooses an item to purchase, it would display to them the item they selected along with a similar item from the competing store. Whichever item is cheaper should be highlighted in some way as to lead the user to a better deal.

Storing the item URLs in text files, I created a shell script that scraped the URLs and saved the HTML files to a temporary folder. Using tagsoup, the HTML files were then converted to XHTML which were fed through a parser written in python. Once the information I required to put on my site was gathered, the items were stored in a MySQL database. Utilizing HTML/CSS to create the front end, I used PHP to drive it.

Homepage:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/home.png?raw=true)
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/home2.png?raw=true)

About:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/about.png?raw=true)

History (Before purchasing an item):
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/historyBefore.png?raw=true)

Viewing an item after choosing it on the homepage:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/viewItem.png?raw=true)

Viewing an item after choosing it on the homepage (zoomed out):
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/viewItem-zoomed.png?raw=true)

Choosing to buy an item after viewing it:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/buyItem.png?raw=true)

Viewing the History page after purchasing items (zoomed out):
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/historyAfter.png?raw=true)

Refunding an Item:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/refundItem.png?raw=true)

Viewing the History page after refunding the last item:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/historyAfterRefund.png?raw=true)

Passing in the URL text files and using curl to scrape the webpages:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/start-scraping.png?raw=true)

Converting the HTML files to XHTML after scraping:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/html-to-xhtml.png?raw=true)

Sending the XHTML through the parser and storing the information in the database (updating since it already exists):
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/parse-and-store.png?raw=true)

The script sleeps for 6 hours after running for the first time:
![alt text](https://github.com/jsgit21/JoesHobbies/blob/main/README_screenshots/sleep.png?raw=true)
