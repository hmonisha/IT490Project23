const express=require('express')
const newRouter=express.Router()
const axios= require('axios')
// the below commment is for when you are using your own internal server through your server you are calling 
// google book api 
// please coment this out if that is the case form line (8-21)
// const encodedParams = new URLSearchParams();
// encodedParams.append("volumeId", "<REQUIRED>");
// encodedParams.append("accessToken", "<REQUIRED>");
// encodedParams.append("shelfId", "<REQUIRED>");

// const options = {
//   method: 'POST',
//   url: 'put your url if you using your own internal server ',
//   headers: {
//     'content-type': 'application/x-www-form-urlencoded',
//     'X-RapidAPI-Key': 'SIGN-UP-FOR-KEY',
//     'X-RapidAPI-Host': 'GoogleBooksraygorodskijV1.p.rapidapi.com'
//   },
//   data: encodedParams
// };

newRouter.get('',async(req,res)=>{
    // res.render('bookList')
    
    try {
        const bookListAPI=await axios.get('https://www.googleapis.com/books/v1/volumes?q=flowers&filter=free-ebooks&maxResults=10')
        // console.log(bookListAPI.data.items)
        if(bookListAPI.status==200){
            // console.log(bookListAPI.data)
            res.render('bookList',{booklist:bookListAPI.data.items})
        }else{
            console.log("loding")
        }
        
        // console.log("hello guys")
    } catch (error) {
        if(error.res){
            console.log(error.res.data)
            console.log(error.res.status)
            console.log(error.res.headers)
        }else if(error.req){
            console.log(error.req)
        }else{
            console.log("error bro",error.message)
    
        }
    }
})
newRouter.get('/:id',async(req,res)=>{
    // res.render('bookList')
    var bookId=req.params.id
    console.log(bookId)
    try {
        const bookDetailsAPI=await axios.get(`https://www.googleapis.com/books/v1/volumes/${bookId}`)
        // console.log(bookDetailsAPI.data)
            console.log(bookDetailsAPI.status)
            res.render('details',{bookDetails:bookDetailsAPI.data})
        // console.log("hello guys")
    } catch (error) {
        if(error.res){
            res.render('details',{bookDetails:null})
            console.log(error.res.data)
            console.log(error.res.status)
            console.log(error.res.headers)
        }else if(error.req){
            console.log(error.req)
        }else{
            // res.render('details',{bookDetails:null})
            console.log("error bro",error.message)
    
        }
    }
})
module.exports=newRouter