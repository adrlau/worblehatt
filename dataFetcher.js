// a simple script to fetch bookdata to the library.


function getIsbn() {
    //TODO :  add input handling for the isbn and return it
    // example isbn = "0801859034" or isbn = 9780135166307  10 or 13 siffer number but with possible 0s at beginning
    let isbn = "";
    return isbn
}

//0801859034 test isbn
// 9784295003687
getFromApisFormatted("9784295003687");
//function to get book data from apis.
async function getFromApisFormatted(isbnInput){
    if (isbnInput.length != 10 && isbnInput.length != 13) {
        console.log("wrong length of isbn. Only 10 or 13");
        return false;
    }

    let bookData = {
        isbn: isbnInput,
        authors: [], //[author1, author2] primary first
        title: "",   //"title: subtitle"  
        publishYear: "", //"1970" yeahr
        numberOfPages: 0, //420   number of pages
        category: [], // ["Programming","C"] a list of categories it fits into
        languages:[], //["eng","nor"] possible with more languages, primary first
        shelf: ""     //where at pvv is it (or supposed to be). 
    }

    // let url = "https://openlibrary.org/isbn/"+isbnInput+".json";
    let url = "https://www.googleapis.com/books/v1/volumes?q=isbn:"+isbnInput;
    var data = fetch(url)
    .then(response => response.json() )
    .then(result => {
        console.log("getting data from googlebooks");
        result=result.items[0].volumeInfo;
        bookData.authors = result.authors;
        bookData.authors.slice(bookData.authors.length-2)
        bookData.title = result.title +": "+ result.subtitle;
        bookData.publishYear = result.publishedDate;
        bookData.numberOfPages = result.pageCount;
        bookData.category = result.categories
        bookData.languages = result.languages
        console.log(bookData);
        

        //TODO: error handling
        if (
            bookData.authors == []  
            || bookData.title == ""
            || bookData.publishYear == ""
            || bookData.numberOfPages == 0
            || bookData.languages == undefined
            || bookData.category == [] //debugging
            )
        {   
            console.log("falling back to openlibrary");
            //prosess and gather new data
            //TODO : get book data from multiple fallback api sources.
            let url = "https://openlibrary.org/isbn/"+isbnInput+".json";
            var data = fetch(url)
            .then(response => response.json() )
            .then(result => {
                //TODO compare diffrent data from previous and current
                if (bookData.authors.length < result.by_statement.replace(" ", "").replace("&","").split(",").length) {
                    bookData.authors = result.by_statement.replace(" ", "").replace("&","").split(","); 
                }

                if (bokData.title.split(": ").length < 2 || bokData.title == ": " || bokData.title == "") {
                    bookData.title = result.title +": "+ result.subtitle;
                }

                if (bookData.publishYear == 0) {
                    bookData.publishYear = result.publish_date;
                }

                if (bookData.numberOfPages == 0) {
                    bookData.numberOfPages = result.number_of_pages;
                }

                // bookData.genres = result. //not in this api.
                if (bokData.languages == [] || result.languages.length >= 2) {
                    for (const language of result.languages) {
                        bookData.languages.push(language.key.substr(11));
                    }
                }

                console.log(bookData);
                pushToDatabase(bokData);
            });
        }else{
            pushToDatabase(bokData);
        }

    });

}

function showInHtml(bookData) {
    
}

function pushToDatabase(bookData) {
    
}