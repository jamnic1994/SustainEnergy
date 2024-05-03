# SustainEnergy
This repository is used for a college project surrounding sustainability and green practices in business.

Its central function is as follows:

1. Allow users to create accounts for their particular organisation
2. Allow those users and organisations to engage in sustainable practices and earn points for their progress and improvement
3. Once point thresholds have been met users can download certificates of achievement that they can use in promotional materials or on their website

There is an admin panel to be used by people with a specific "admin" role on their accounts database record. This gives them access to a set of controls over users accounts. They have the ability to delete accounts, suspend and reinstate accounts, as well as give and remove users subscriptions.

The points thresholds are currently set to: 

1. Bronze: 50pts
2. Silver: 75pts
3. Gold: 100pts

If these are to be changed then ensure that you also change the SQL trigger in the database, this automatically changes a users award field when a new threshold is met by a user.

There is an export of the database structure in the folder that you can import into your database server.
