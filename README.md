**Feedback Module**

**ETA**: 3 days

**Task 1:**

First create a module named Feedback.

**1. Display customer feedback link at footer**

Now create a template file having feedback link and add the template in layout file

**2. Display the form in the customer feedback landing page and form will have the below fields**

**Create a new route ** and in that create a new pagefactory and have the below fields

We should check if the customer has logged in, if yes

Then populate it from database

1. Customer first name. 2. last name, 3. email, 4. Comment text area

**3. Magento form validation**

Once you get the details from the form use inbuilt magento form validation.

**4. Once customer submit the feedback redirect them to home page and display success message in message box.**

After submitting the form store the data in a database, we will have another table which has status and initially we will have it as 2

0->admin has rejected

1->admin has selected

2->admin has not reviewed it

Use resultRedirectFactory and redirect them to homepage and implement a toast message using addSuccessManager

**5. In admin panel to display "Customer Feedback" tab under customer menu**

Create a custom module and define a new admin menu item in menu.xml and create a controller and redirect the action there

**6. Display the list of submitted feedback in grid view with sort, search, pagination**

Retrieve the data from database and display it as grid view using ui components including sort,search and pagination

**7. If admin click Approve button will send email to customer saying your feedback has approved, if admin click Decline button email should be sent as decline message.**

In the list of reviews you will have a link which will redirect you to that detailed review which is implemented by creating a controller and there admin has the access to reject or accept the review.If admin clicks reject,then the particular review in db is changed to 0 and if he accepts then the particular review in db is changed to 1.

**8.Display the status column in admin grid**

**9.Once customer submits the form send the email to customer and bcc to store admin**

Here we will use the transport builder module and send the details (template,to email address,from email address)

This is done using MailTrap Module.

**MAILTRAP MODULE CONFIGURATIONS:**

**1.install smtp using composer**

**2.create an account in mailtrap**

**3.Go to Stores -> Configuration -> Advanced -> System -> SMTP Configuration and Settings.**

**4.Enable Mailtrap’s Email API/SMTP Service.**

**5.Host: sandbox.smtp.mailtrap.io**

**6.Port: 465**

**7.Protocol: TLS**

**8.Username: 30ba87828b593d (You will get it from mailtrap)**

**9.Password: (You will get from mailtrap)**
