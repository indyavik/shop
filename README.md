##### About this project: 
A Personal projects that implementing a number of order management functionality for e-Commerce prescription eyewear store that leverages shopify. Main objectives are - 
  -  Retrieve and store order data from shopify and store in the local database (database is mongodb)
  -  Provide Ability to update and modify order information (outside shopify), create and send order data to related third parties (primarily in pdf format)  
  - Additional order status management functionalities (specific to prescription eyewear business) that are not available out of     the box elsewhere

########################################################
#####  Key notes: 
- Relies on shopify API (without any external adaptor), and (potentially) webhook.

- Project uses PHP and PHP-TWIG for templating and attempts to follow MVC patterns but does  not use a web framework (I looked for 'flask' or 'sinatra' like micro framework for php but didn't find exactly what was looking for).  
########################################################

Development notes:
  - database-> "api"
  - collections : pstuff (no unique index), users, and recent 

PRODUCTION To DOs:
  - use mongodb auth 
  - use appropriate collections indentifiers 
