
Nestbox is a simple tweet archiver built on Codeigniter framework. It uses the Twitter search API to archive tweets with a selected hashtag into a MongoDB database.

Displays the tweets as a table (that can be copy-pasted into Excel, for example). Also shows a list of tweeters by tweet count.

How to use it
-------------

1. Get [http://codeigniter.com/](Codeigniter), configure it according to your server
2. Copy Nestbox files into Codeigniter's directories
3. Set up a MongoDB database (e.g. [https://mongolab.com/](MongoLab))
4. Save your database details (username etc) into a file (example in the "0" directory)
5. Set a cronjob to fetch tweets with a hashtag (example in the "0" directory)
