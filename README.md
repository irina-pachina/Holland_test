# Holland Code Test
Small CLI module that adapts [Holland Code Test](https://openpsychometrics.org/tests/RIASEC/) to Russian language using endpoints of the Open-Source Psychometrics Project.
- - -
For my passion project, I needed to adapt this test to the Russian language for localization purposes. It was good to find out that questions are stored and answers data set is formed completely on the client side (in [https://openpsychometrics.org/tests/RIASEC/1.php](https://github.com/irina-pachina/Holland_test/blob/master/original.php)) so I got all the requirements.
Therefore this module has a CLI that asks questions in Russian and forms answers in the expected format. Then it is sent through the POST method to the endpoint that calculated test results and the response is parsed to get Holland's code.
There is also a function to check if data format or questions change in *1.php* that is planned to run regularly.
