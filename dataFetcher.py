# a simple script to fetch bookdata to the librar.

# ISBN
# Forfatter
# Tittel
# Utgivelsesår
# Antall sider
# Sjanger
# Språk
# Bruker som har lånt boken
# Dato på når boken ble lånt ut

import requests
import json



def getIsbn():
    #TODO :scanning isbn and input
    # isbn = 9780135166307 #input gir ett isbn 10 eller 13 nummer   # kaster en error.
    isbn = "0801859034" #input gir ett isbn 10 eller 13 nummer

    # isbn = input("scan a book or add manually") #input gir ett isbn 10 eller 13 nummer
    # try:
    ## some input validation
    if (len(isbn) == 10 or len(isbn) == 13):
        return str(isbn)
    else:
        # raise Exception
        return "error"
    # except:
    #         return "error"
    

def getFromApi(isbn):
    try:
        #google books api
        jsonInput = json.load("https://www.googleapis.com/books/v1/volumes?q=isbn:"+isbn)

        authors = list(set(jsonInput.get("authors")))
        title = jsonInput.get("title") + jsonInput.get("subtitle")
        publishDate = jsonInput.get("publishedDate")
        numberOfPages = jsonInput.get("pageCount")
        languages = list(set(jsonInput.get("languages")))
        

        if authors == None or title == None or publishDate == None or numberOfPages == 0 or languages == None:
            # openlibrary
            jsonInput = json.loads(requests.get("https://openlibrary.org/isbn/"+str(isbn)+".json").text)
            if authors == None:
                authors = jsonInput.get("authors")
                for i in range(len(authors)):
                    authors[i] = json.loads(requests.get("https://openlibrary.org"+str(authors[i].get("key"))+".json").text).get("name") #henter navn fra api
                authors = list(set(authors))
            
            if title == None:
                title = jsonInput.get("title")
                
            if publishDate == None:
                publishDate = jsonInput.get("publish_date")
            
            if numberOfPages == None:
                numberOfPages = jsonInput.get("number_of_pages")
            
            if languages == None:
                languages = jsonInput.get("languages")
                for i in range(len(languages)):
                    languages[i] = json.loads(requests.get("https://openlibrary.org"+str(languages[i].get("key"))+".json").text).get("name")
        
        
        bookData = {
                    "authors": authors,
                    "title": title,
                    "publishDate": publishDate,
                    "numberOfPages": numberOfPages,
                    "languages": languages,
                    }
        return bookData

    except:
        return "error gathering data"



def pushToDatabase(bokdata):
    print("pushing to databse")
    #TODO :Database work


if __name__ == '__main__':
    while True:
        isbn = getIsbn()
        try:
            if isbn != "error":
                bokData = getFromApi(isbn)
            else:
                raise Exception
        except:
            print("not a valid isbn, try again")
            continue
        
        try:
            print("is this correct?")
            print(bokData)
            answered = False
            while not (answered):
                answer = input("y or n")
                if (answer == "y"):
                    answered = True
                elif(answer == "n"):
                    answered = True
            
            if answer == "n":
                #TODO:implement functioning data editing
                print("wat was wrong")
                answered = False
                while (not answered):
                    answer = input("1: authors   /n 2:     /n 3:   /n q: continue")
                    if (answer == "1"):
                        answer = input("input the correct authors seperated by a , ")
                        
                    # elif(answer == "2"):
                        
                    elif(answer == "q"):
                        answered = True
                
            
            if answer == "y":
                print("push to database?")
                answered = False
                while not (answered):
                    answer = input("y or n")
                    if (answer == "y"):
                        answered = True
                    elif(answer == "n"):
                        answered = True
                if answer == "y":
                    pushToDatabase(bokData)
            
        except:
            print("did not get valid data")
            continue


