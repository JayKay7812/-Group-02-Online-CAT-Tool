import re
def cut_sent(infile, outfile):
  cutLineFlag = ["？", "！", "。","…"] #本文使用的终结符，可以修改
  sentenceList = []
  with open(infile, "r", encoding="UTF-8") as file:
    oneSentence = ""
    for line in file:
      if len(oneSentence)!=0:
        sentenceList.append(oneSentence.strip() + "\r")
        oneSentence=""
      # oneSentence = ""
      for word in words:
        if word not in cutLineFlag:
          oneSentence = oneSentence + word
        else:
          oneSentence = oneSentence + word
          if oneSentence.__len__() > 4:
            sentenceList.append(oneSentence.strip() + "\r")
          oneSentence = ""
