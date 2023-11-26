# CS234-Semester-Project
A simple course registration website that can be ran locally, developed for CS234.

## What this Website Does (in more detail)
This website allows users to register under a username and a password complying with specific character length, among other things.

The adminstrator **admin** is automatically created upon the first user's registration. 
![Registration Page](assets\screenshots\register.jpg)

## User (not admin) Controls
Upon opening the website for the first time, you should be at the login page. Click **Register** to register an user account, making sure to follow the password requirements.
![Login Page](assets\screenshots\login.jpg)

If the user already exists or the password doesn't meet the requirements, an error page is shown. 
![User Already Exists Error](assets\screenshots\userexists.jpg)

If a user is successfully registered, you will be redirected back to the login page, where you can then log in.

Upon logging in, you have a couple options. You can register (if you don't have any courses scheduled), or you can view your schedule if you've already done so. There's a bit of oversight here, as viewing your schedule allows you to add/drop classes, somewhat similar to registering.
![Home Page (Normal User)](assets\screenshots\homenormal.jpg)

![Register Courses (Normal User)](assets\screenshots\registernormal.jpg)

The real power comes in viewing your schedule, where you can see your active courses and then decide to remove them or add more if wanted.
![View Schedule (Normal User)](assets\screenshots\viewschedulenormal.jpg)

## Admin Controls
The adminstrator's username and password is pre-determined upon loading the website. It doesn't follow the same requirements as a normal user. To log in as adminstrator, type:
```
username: admin
password: admin
```
As an admin, you have a lot more control over individual users/students.
![Admin Home](assets\screenshots\adminhome.jpg)

You can create a user and immediately register their courses, much like normal users, or you can remove active users from the database. 
![Delete Users](assets\screenshots\deleteusers.jpg)

The adminstrator can also add or remove courses from a user's schedule.

Lastly, the adminstrator has power to view all users and their schedules at once. 
![View Users](assets\screenshots\viewusers.jpg)


## Closing Thoughts
All in all, I think it looks okay, especially for my level of expertise. A small amount of CSS (and flexboxes) can do a lot for a simple HTML page!