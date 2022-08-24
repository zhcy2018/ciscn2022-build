# -*- coding:utf-8 -*-
import sys
import re

import requests

#除了返回的正常/错误，其余不输出任何信息，且需要设置超时时间！使用python3进行编写

# 检查语句
def check1(url):
    try:
        res=requests.get(url+'/index.php',headers={"Authorization": "Basic MTUzNjYxNjI1ODY6SWtncWIzdEQ="},timeout=3)
        if(res.status_code!=200):
            raise Exception("Check1 error, index.php wrong")
        
    except Exception as e:
        raise Exception("Check1 error, index.php wrong")
    return True

def check2(url):
    try:
        res=requests.get(url+'/common.php',headers={"Authorization": "Basic MTUzNjYxNjI1ODY6SWtncWIzdEQ="},timeout=3)
        if(res.status_code!=200):
            raise Exception("Check2 error, common.php wrong")
        
    except Exception as e:
        raise Exception("Check2 error, common.php wrong")
    return True

def check3(url):
    try:
        res=requests.get(url+'/init.php',headers={"Authorization": "Basic MTUzNjYxNjI1ODY6SWtncWIzdEQ="},timeout=3)
        if(res.status_code!=200):
            raise Exception("Check3 error, init.php wrong")
        
    except Exception as e:
        raise Exception("Check3 error, init.php wrong")
    return True

# 控制语句
def checker(host, port):
    try:
        url = "http://"+ip+":"+str(port)
        if check1(url) and check2(url) and check3(url):
            return (True,'"status": "up", "msg": "OK"')  # check成功返回字段。"status": "up", "msg": "OK"
    except Exception as e:
        return (False, '"status": "down", "msg": "ERROR"')  # check不成功返回字段。"status": "down", "msg": "ERROR"

# 主逻辑
if __name__ == '__main__':
    ip=sys.argv[1]
    port=int(sys.argv[2])
    print(checker(ip,port))
