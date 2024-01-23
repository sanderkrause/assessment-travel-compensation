# Assessment: Travel Compensation

This is a very naive implementation of an assessment regarding travel cost compensation. As a lot of information is not specified, I've made some assumptions. These assumptions are listed in the Known issues section.

## Requirements
Note: These requirements may not be accurate, but represent the system on which the application was developed.
- PHP 8.3

## Setup
1. Clone the repository
2. Run `composer install`
3. Run `bin/console app:calculate-compensation`
4. The output file should be generated as `compensation.csv`

## Rationale
This is a very simple Symfony CLI single-command application for the specific purpose of an assessment. 
More code to put the same hard-coded data into a database and retrieve it from there would be overkill.

## Tests
Not included for the sake of not being paid to do this assessment. 
Note: tests would have added value when specific working days are specified, as that would enable actually calculating the compensation for each month. See the next section for more information.

## Known issues and caveats
The assessment makes note of the fact that employees who travel over 10 kilometers one-way prefer a different way of commuting. 
However, one case is mentioned in the data where an employee travels 11 kilometers one-way by bike. 
This is not taken into account, as it's not specified what the preferred way of commuting is.

As it's not specified which weekdays employees are working, the average for each week is taken. 
No national holidays have been taken into account.
Time off is not taken into account as that data was not available.
Compensation is not adjusted for half-days, meaning that if an employee works 4 hours on a day, they will be compensated for the whole trip just as any other day.

Without specific data on which days are worked, it's impossible to accurately calculate the compensation for each individual month. 
Thus, the only sane way to do this is to calculate the average compensation per week and multiply that by 52, then divide that by 12 to get the average for each month. 
This is expected to be inaccurate for any real-world scenario.
