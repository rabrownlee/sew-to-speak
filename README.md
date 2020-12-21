# csci3172project
Names:  
- Kaitrin Harnish [B00579658]  
- Rachel Brownlee [B00738899]   


Class:      
- CSCI3172 - Web Centric Computing   


Prof:       
- Pat Crysdale  

Date:   
- Nov-Dec 2020   

LINK: 
--------------------------------------
https://git.cs.dal.ca/kharnish/csci3172project.git


ABOUT:  
--------------------------------------

We had originally planned on using the MEAN framework; however, we had serious 
problems during development. One of our laptops died and needed to be replaced. 
We couldn't get some of the frameworks installed properly on the new laptop, and
Angular.JS was not working as expected on both devices. After some serious 
consultation as a team, we decided that we needed to adjust our plan in order to
have something to submit by the due date. We have left an unmerged branch to 
show our initial start with using the MEAN Framework. We abandoned that part of 
the project due to the aforementioned issues. 

We ended up creating this website in combination of Bootstrap and PHP. It is 
still a working project, as it is missing some of our intended functionality. 
The missing functionalities are explained below. We also were not able to fully
implement the security features we had planned to, and therefore there are some
identified vulnerabilities which will be updated in the final milestone. 

We used a Blog template from Bootstrap as our starting point and adjusted as our
requirements involved different aspects than the template provided. The two 
templates we used were the Home Page and Post Page. We adapted these templates 
to create the Home Page, Post Page, and Sign Up page.

The purpose of this project was to create an online content management system 
for an online embroidery database for members to connect, communication, and 
learn.

Below are the programs required to use this website. 

PROGRAMS TO INSTALL: 
----------------------
MAMP (we used the base version, but you are able to use MAMP PRO if you have it)

DATABASE DESCRIPTION:
-----------------------
- Blog database containing many users. Users create Posts. Outside users create 
  Comments on a respective Post. 
- Within the MISC folder is the exported Database file that contains the 
  statements used to create certain parts of the database. For the structure, 
  We created the skeleton and then used INSERT VALUES statements for all areas 
  based on the information within the .CSV file provided in the files folder. 
- Within each .php file is a description of the searches that are used for each 
  aspect of the database. I.E. On index, all Posts are retrieved and organized 
  into cards. They are organized by date, newest being shown first. On each 
  Post.php page, there is a database query to retrieve the actual post 
  information as well as the Comments. 

INSTRUCTIONS TO RUN: 
-----------------------
- If not already installed, please install MAMP. 
- Set mamp settings to the following: 
    GENERAL: Update to your preference, as these will not affect the website. 
    PORTS: "Set MAMP ports to default" This should set up the following: 
        Apache Port: 8888
        Nginx Port: 8888
        MySQL Port: 8889 
    PHP: Standard Version 7.3.8, Cache OFF
    WEB SERVER: "Web Server: Apache", "Document Root: MAMP/htdocs"
    MYSQL: "Active Version: 5.7.26"
    CLOUD: Not applicable
- Clone/download all files in this repository into the following folder: 
  /Applications/MAMP/htdocs 
- Open MAMP
- Click "Start Servers"
- The MAMP home page will open. 
- Navigate to "Tools" 
- Open "phpMyAdmin"
- A new webpage will open for PHPMYADMIN 
- Click "Import" on the top task bar of PHPMYADMIN
- Under "File to Import", click "Choose File" next to "Browse Your Computer"
- Navigate to MAMP/htdocs/csci3172project-master/misc/Database_Export_File.txt
- Leave default settings as is, and click "Go". If this gives you any errors, 
  please run again but unclick "Enable foreign key checks" under "Other Options"
- Exit PHPMYADMIN webpage
- On the MAMP Homepage, click "My webpage" - this will load the webpage. 

MISSING FUNCTIONALITIES: 
--------------------------
- We were not able to fully create the Admin functionality; however, this was 
  expected and expressed during the planning phase. We had initially wanted to 
  create about 75% of the functionality of the website; however, I'd say we 
  we ended up with approximately 60% functionality. We plan to update and add
  the missing functionalities for the next milestone. 
- Users cannot currently upload their images as we had not ironed out image
  storage. Originally we planned to store them in the database; however, that 
  would require a large amount of space. We are exploring online storage options
  We will find a solution and implement this in the next milestone. 

VULNERABILITIES: 
-----------------------
- The website is currently full of vulnerabilities; however, the expectation 
  for this milstone was not necessarily to have all of the vulnerabilities 
  prevented. Given that the pen-testing is happening in the final milestone, 
  we plan to prevent vulnerabilities for that milestone. Our main vulnerability
  is lack of in-depth user interaction validation, which includes changing the 
  source code or SQL injection. 
- SQL is liking going to be a prominant and unfixable vulnerability for this 
  specific site as prepared statements were not working for database interaction


Citations: 
----------
Bootstrap. (n.d.). Blog Post - Free Bootstrap 4 Blog Starter Template. Retrieved December 2020, from https://startbootstrap.com/templates/blog-post/. [1]

Bootstrap. (n.d.). Blog Home - Free Bootstrap 4 Blog Template. Retrieved December 2020, from https://startbootstrap.com/templates/blog-home/. [2]

Otto, M., & Thornton, J. (n.d.). Forms. Retrieved December 2020, from https://getbootstrap.com/docs/4.0/components/forms/.