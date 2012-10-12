Vote-Amercia
============

SMS voting app built for the #ElectionClass primary election.

Uses PHP, Twilio, and a little magic.

--------

1) Users are verified by "netid", which have been stored in a users table. 

  1.1) The first time a user votes, their phone number is tied to their profile

  1.2) If a phone number is already set in their profile, all future votes must come from that number

2) Once authenticated an anonymous vote for the candidate is recorded in the votes table.

  2.1) An entry is also placed in the log table, noting the election the user voted in.
  
  2.2) Users can only vote once in each election
  
---------

by Andrew Bauer (@awbauer9) and Chris Becker (@cbeck527)