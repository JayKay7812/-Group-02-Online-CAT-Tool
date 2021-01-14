#coding:utf-8
import json
import flask
from flask import Flask, request, render_template,make_response,jsonify,abort
import nltk
from nltk.tokenize import sent_tokenize, word_tokenize
import jieba
import pymysql
from flask_cors import *
import difflib

host, port, db = 'localhost', 3306, 'cat'
user, passwd = 'root',''

def gen_http_result():
    res = {
        'status': 'ok', 
        'msg': '',
        'data': []
    }
    return res

def make_resp(ret):
    resp = make_response(json.dumps(ret,ensure_ascii=False))
    resp.mimetype = 'application/json'
    resp.headers['Access-Control-Allow-Origin'] = '*'
    resp.headers['access-control-allow-headers'] = 'Authorization, Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, X-Requested-By, If-Modified-Since, X-File-Name, X-File-Type, Cache-Control, Origin'
    resp.headers['access-control-allow-methods'] = 'GET, POST, OPTIONS, PUT, DELETE'
    resp.headers['access-control-expose-headers'] = 'Authorization'
    return resp

def get_term(lan,str,tsid): #语言，句段，术语表id
    try:
        conn = pymysql.connect(host=host, port=port, user=user, passwd=passwd, db=db, charset='utf8')
        cur = conn.cursor()
        SQL = "SELECT zh_CN,en_US FROM termbase where (zh_CN='{}' or en_US='{}') and tbsheet_ID={} ;".format(str,str,tsid)
        cur.execute(SQL)
        r = cur.fetchall()
        r=list(r[0])
        if(lan=="zh-CN"):
            pass
        elif(lan=="en-US"):
            r[0],r[1]=r[1],r[0]
        r.insert(1,"100")
        return r
    except Exception as e:
        print(e)
        return 0


def get_equal_rate(str1, str2):
   return difflib.SequenceMatcher(None, str1, str2).quick_ratio()

def get_tm(s,id): #句段，翻译记忆库id
    try:
        conn = pymysql.connect(host=host, port=port, user=user, passwd=passwd, db=db, charset='utf8')
        cur = conn.cursor()
        SQL = "SELECT sourceText,targertText FROM translationmemorybase where tmsheet_ID = {};".format(id)
        cur.execute(SQL)
        r = cur.fetchall()
        index=["Source","rate","Target"]
        result=[]
        for t in r:
            rate=get_equal_rate(s,t[0])
            if(rate>=0.5):
                t=list(t)
                t.insert(1,round(rate*100))
                tm=dict(zip(index,t))
                result.append(tm)
            else:
                pass
        result=sorted(result, key = lambda i: i['rate'],reverse=True)
        return result
    except Exception as e:
        print(e)
        return []

app = Flask(__name__)
CORS(app, supports_credentials=True)

@app.route("/process/<tsid>/<id>",methods=["POST","GET"])
def process(tsid,id): #翻译表id，句段id
    ret = gen_http_result()

    tsid=tsid
    tid=id

    conn = pymysql.connect(host=host, port=port, user=user, passwd=passwd, db=db, charset='utf8')
    cur = conn.cursor()
    SQL_type="select sourceLanguage from translationsheet where translationsheet_ID = '{}';".format(tsid) #查询源语言
    cur.execute(SQL_type)
    lan = cur.fetchone()

    SQL_pro="select project_ID from translationsheet where translationsheet_ID = '{}';".format(tsid) #查询项目id
    cur.execute(SQL_pro)
    pro = cur.fetchone()

    SQL_tb="select tb_ID from relationsheet2 where project_ID = '{}';".format(pro) #查询所用术语表id
    cur.execute(SQL_tb)
    tbid = cur.fetchone()

    SQL_tmb="select tmb_ID from relationsheet1 where project_ID = '{}';".format(pro) #查询所用翻译记忆表id
    cur.execute(SQL_tmb)
    tmbid = cur.fetchone()

    SQL = "SELECT sourceText FROM translationbase where translation_ID='{}';".format(tid)
    cur.execute(SQL)
    r = cur.fetchone()

    word_list=()
    if(lan[0]=="en-US"):
        word_list = nltk.word_tokenize(r[0])
    elif(lan[0]=="zh-CN"):
        word_list = jieba.cut(r[0])
    
    term=[]
    index=["Source","rate","Target"]
    for w in word_list:
        if(get_term(lan,w,1)):
            list1=dict(zip(index,get_term(lan,w,1)))
            term.append(list1)
        else:
            pass
    

    tm=[]
    tm=get_tm(r[0],2)
    

    seq = ('term', 'tm')
    result = dict.fromkeys(seq)
    result['term']=term
    result['tm']=tm

    ret['data']= result
    rsp = make_resp(ret)

    return rsp


if __name__ == "__main__":
    app.run(debug = True)
