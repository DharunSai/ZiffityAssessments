# SOLUTION APPROACH

# REQUIREMENTS
Car parking vault using PHP, OOPS and MySQL 
- There are totally 10 parking lots
- create a user page - with login, select lot, vehicle number, duration, calculate and display price for duration
- create an admin page -  list of utilization as table: vehicle number, duration, bill amount and timestamp
- use validations wherever necessary



# WORK FLOW

1.If the user hasn't created an account he will have to create an account and then login
2.Once you login you will have to select the slot and enter car number you want to park
3.After you press the unpark button, it will provide you with a receipt on the duration and fare
4.You also have an admin page where you can see all the details of the parked cars

----->USER module
This module takes care of the signup and login feature by creating a user and authenticating the user.
sub module------>login
              Here it will retrieve the record from user table using username and verify the password and authenticate and store it in session
           ------>signup
              Here it will add a new user to the users table after validating the input and check whether the username is available or not

              



------>UTILIZATION module
This module is used to record the intime and outtime where we give in the userid,carnumber,slotid

submodule------>intime
              recordInTime:
              .Here it will update the slot that we have clicked to parked first
              .Now we will insert the data to utilization table
        -------->outtime
              recordouttime:
              Here we will get the slotid using userid which we stored in session
              we will update the slot to unparked
              Then will update the utilization table's outtime


--------->PARKING LOT module
          Here we will get the available slots,filled slots,get the assigned slots by the user,is slot available and update the slots
           updateslots:
               Here it will update the slot to either parked or unparked on the slotid

          

------>RECEIPT module
This module will take in details from the utilization table and calculate the duration and fare using intime and outtime

        Here we will generate the recceipt by getting the data from the utilization table based on the user id we calculate duration and fare
        For duration we will first convert the str to time and then we will get the difference

        

------->ADMIN module
This module is used to print all the details of the parkings



# ETA

eta: 2days(16 hours)

realTime: 3days(24 hours)

reason for delay: Had issue with debugging the code in the reccord outtime.

# TEST CASES:
signup: {Dharun,Dharun@123}

login:{Dharun,Dharun@123}

dashboard: {carno: 1323, slotid: 3}

Result: passed

# ERRORS:

Solved all the errors





