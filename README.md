Milestones
==========

Milestones is a color-gradiated to-do and to-done list. Originally a CS494 Web Dev final project.

[a link](http://travisjsanders.com/milestones/)

I wanted to make a to-do application that focused on short-term goals for the present and long-term accomplishments in the past. I quit smoking a little over three years ago, and looking at the amount of time that’s passed since my last cigarette really helped me early on in that process. 

So, as ‘milestones’ get closer to the present they become redder and as they get further away from the present, they become greener. I spent a ton of time on styling and learning more Bootstrap css tricks. 
 
I used three libraries outside of the scope of the course. For starters, (like about half of the class), I used PHPass to hash and validate my passwords. I didn’t feel entirely comfortable being able to see the passwords people were logging into my site with, final project or not. This was an interesting look into security. I thought that each password string would hash to the same hash string, but identical passwords have very different hashes. 
 
To do the date comparison, I use a library called MomentJS. It’s extremely simple to use. Calling the function moment() returns the current date and time in a JS object that can be compared to other moments, extended for any duration as a time span, outputted to any number of different date and time formats, and described in relation to the present in human-understandable language. There weren’t any functions to represent time as a percentage, so I had to roll my own color gradients using the array of events min / max and the current moment() to calculate percentages. (I spent a lot of time on the colors.) 
 
User input was a potential source of extremely huge headaches when it came to date validation, so I found another library to do it for me. bootstrap-datepicker required a bit more css and js installation than the other libraries, but it was well worth it. There’s a nice visual interface to tap in dates, input as a string works extremely well, and it prevents the user from entering anything that isn’t a valid date. 