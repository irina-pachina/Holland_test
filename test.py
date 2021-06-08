import random
import json
import os.path
import requests
import logging
from bs4 import BeautifulSoup


logging.basicConfig(filename='test_log.txt', filemode='a', format='%(levelname)s - %(asctime)s - %(message)s',
                    datefmt='%d-%b-%y %H:%M:%S', level=logging.DEBUG)


def load_file(file_name, ext=None):
    file_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), file_name)
    with open(file_path, encoding='utf-8') as f:
        if ext == "json":
            file = json.load(f)
        else:
            file = f.read()
    return file


def form_answers():
    item_order = ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'I1', 'I2', 'I3', 'I4', 'I5', 'I6', 'I7', 'I8', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8'];
    random.shuffle(item_order)

    questions = load_file("questions_ru.json", "json")

    test_data = {}

    for index, item in enumerate(item_order):
        print(f"""{questions[item]}
        1. Dislike/Совершенно не нравится
        2. Slightly dislike/Скорее не нравится, чем нравится
        3. Neutral/Нейтрально
        4. Slightly enjoy/Скорее нравится, чем не нравится
        5. Enjoy/Нравится""")
        ans = input()
        while 1:
            if len(ans) > 1 or not ans.isdigit() or int(ans) not in range(1,6):
                ans = input("Only number from 1 to 5: ")
            else:
                break
        test_data[item + "A"] = int(ans)
        test_data[item + "I"] = index + 1
        test_data[item + "E"] = random.randint(1000, 700000)
    logging.info(f'test_data = {test_data}')
    return test_data


def get_results(answers):
    test_data = {"testdata": f'{answers}'}
    r = requests.post('https://openpsychometrics.org/tests/RIASEC/2.php', data=test_data)
    if r.status_code == 200:
        soup = BeautifulSoup(r.text, features="html.parser")
        logging.info(f"""2.php response: 
{soup.prettify()}""")
        code_score = {"R": soup.find(attrs={"name": "R"})['value'], "I": soup.find(attrs={"name": "I"})['value'],
                      "A": soup.find(attrs={"name": "A"})['value'], "S": soup.find(attrs={"name": "S"})['value'],
                      "E": soup.find(attrs={"name": "E"})['value'], "C": soup.find(attrs={"name": "C"})['value']}
        logging.info(f'code_score = {code_score}')
        return "".join(sorted(code_score, key=code_score.get, reverse=True))
    else:
        print(f"Error: status code {r.status_code}")
        return 0


def check_php_algorithm():
    r = requests.get('https://openpsychometrics.org/tests/RIASEC/1.php')
    if r.status_code == 200:
        current_php = r.text
        soup = BeautifulSoup(current_php, features="html.parser")
        seconds = soup.find(attrs={"name": "seconds"})
        seconds['value'] = "0"
        current_php = soup.prettify()
        file = open('current_php.php', 'w', encoding='utf-8')
        file.write(current_php)
        file.close()
    else:
        print(f"Error: status code {r.status_code}")
        return 0

    original = load_file("original.php")
    new = load_file("current_php.php")

    # if file is changed
    # split_A = set(new.split("\n"))
    # split_B = set(original.split("\n"))
    # set_difference = split_B.difference(split_A)
    # list_difference = list(set_difference)
    # print(list_difference)

    if original == new:
        return 1
    else:
        return 0


# formed on UI
# answers = {"S4A":2,"S4I":5,"S4E":679504,"E4A":3,"E4I":2,"E4E":1169,"A3A":1,"A3I":3,"A3E":1100,"S2A":3,"S2I":4,"S2E":141126,"A7A":4,"A7I":1,"A7E":1232,"E5A":2,"E5I":6,"E5E":1028,"E1A":1,"E1I":7,"E1E":1066,"R4A":5,"R4I":8,"R4E":1218,"R8A":3,"R8I":9,"R8E":878,"I6A":4,"I6I":10,"I6E":809,"I4A":2,"I4I":11,"I4E":828,"R7A":1,"R7I":12,"R7E":795,"E8A":3,"E8I":13,"E8E":962,"S1A":4,"S1I":14,"S1E":838,"C2A":5,"C2I":15,"C2E":802,"C7A":4,"C7I":16,"C7E":805,"C5A":3,"C5I":17,"C5E":786,"E3A":3,"E3I":18,"E3E":181,"I2A":3,"I2I":19,"I2E":327,"E2A":3,"E2I":20,"E2E":318,"S8A":3,"S8I":21,"S8E":310,"S3A":3,"S3I":22,"S3E":351,"C1A":3,"C1I":23,"C1E":335,"E7A":3,"E7I":24,"E7E":334,"R2A":4,"R2I":25,"R2E":793,"S6A":4,"S6I":26,"S6E":357,"I1A":2,"I1I":27,"I1E":674,"E6A":2,"E6I":28,"E6E":355,"C3A":2,"C3I":29,"C3E":362,"C6A":1,"C6I":30,"C6E":810,"I3A":1,"I3I":31,"I3E":276,"I7A":5,"I7I":32,"I7E":1132,"A6A":5,"A6I":33,"A6E":260,"A5A":4,"A5I":34,"A5E":582,"A4A":2,"A4I":35,"A4E":735,"A1A":3,"A1I":36,"A1E":898,"A8A":3,"A8I":37,"A8E":199,"S7A":3,"S7I":38,"S7E":299,"C4A":3,"C4I":39,"C4E":372,"A2A":1,"A2I":40,"A2E":712,"R3A":1,"R3I":41,"R3E":326,"R1A":1,"R1I":42,"R1E":351,"C8A":1,"C8I":43,"C8E":358,"I5A":4,"I5I":44,"I5E":732,"R5A":4,"R5I":45,"R5E":218,"S5A":4,"S5I":46,"S5E":514,"I8A":4,"I8I":47,"I8E":216,"R6A":2,"R6I":48,"R6E":8400}

if check_php_algorithm():
    user = input("Enter your login: ")
    answers = form_answers()
    holland_code = get_results(answers)
    print(f"Your Holland's code is {holland_code}")
    logging.info(f'user_login: {user}, code: {holland_code}')
