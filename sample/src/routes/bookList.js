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
}) //routing for first page 

newRouter.get('/:id',async(req,res)=>{
    // res.render('bookList')
    var bookId=req.params.id
    console.log(bookId)
    try {
        const bookDetailsAPI=await axios.get(`https://www.googleapis.com/books/v1/volumes/${bookId}`)
        const recmAPI= await axios.get('https://www.googleapis.com/books/v1/volumes?q=flower&filter=free-ebooks&maxResults=12')
        // console.log(recmAPI.data)

            console.log(bookDetailsAPI.status)
            Promise.all([bookDetailsAPI,recmAPI]).then((data) => {
                res.render("details", {
                    bookDetails: data[0].data,
                    recam: data[1].data.items
                
                });
            }).catch(err => console.error('There was a problem', err));
            // res.render('',{bookDetails:bookDetailsAPI.data,recam:recmAPI.data})
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
newRouter.get('',async(req,res)=>{
    res.render('addedBook')
    
     
})
//routing for 2nd page
// this is for the parsering the elemet to the details [page]
// newRouter.get('',async(req,res)=>{
//     // res.render('bookList')
    
//     try {
//         const bookListAPI=await axios.get('https://www.googleapis.com/books/v1/volumes?q=harry&filter=free-ebooks&maxResults=12')
//         // console.log(bookListAPI.data.items)
//         if(bookListAPI.status==200){
//             // console.log(bookListAPI.data)
//             res.render('details',{booklist:bookListAPI.data.items})
//         }else{
//             console.log("loding")
//         }
        
//         // console.log("hello guys")
//     } catch (error) {
//         if(error.res){
//             console.log(error.res.data)
//             console.log(error.res.status)
//             console.log(error.res.headers)
//         }else if(error.req){
//             console.log(error.req)
//         }else{
//             console.log("error ",error.message)
    
//         }
//     }
// })

// newRouter.post('',async(req,res)=>{
//     // res.render('bookList')
//     var search=req.body.search
//     // console.log(bookId)
//     try {
        
//         const recmAPI= await axios.get(`https://www.googleapis.com/books/v1/volumes?q=${search}&filter=free-ebooks&maxResults=12`)
//         // console.log(recmAPI.data)

//             console.log(bookDetailsAPI.status)
//             Promise.all([bookDetailsAPI,recmAPI]).then((data) => {
//                 res.render("details", {
//                     bookDetails: data[0].data,
//                     recam: data[1].data.items
                
//                 });
//             }).catch(err => console.error('There was a problem', err));
//             // res.render('',{bookDetails:bookDetailsAPI.data,recam:recmAPI.data})
//         // console.log("hello guys")
//     } catch (error) {
//         if(error.res){
//             res.render('details',{bookDetails:null})
//             console.log(error.res.data)
//             console.log(error.res.status)
//             console.log(error.res.headers)
//         }else if(error.req){
//             console.log(error.req)
//         }else{
//             // res.render('details',{bookDetails:null})
//             console.log("error bro",error.message)
    
//         }
//     }})
newRouter.post('',async(req,res)=>{
    // res.render('bookList')
    var search=req.body.search
    // console.log(bookId)
    try {
        const bookDetailsAPI=await axios.get(`https://www.googleapis.com/books/v1/volumes?q=${search}&filter=free-ebooks&maxResults=10`)
        // console.log(bookDetailsAPI.data)
            console.log(bookDetailsAPI.status)
            res.render('search',{booklist:bookDetailsAPI.data.items})
        // console.log("hello guys")
    } catch (error) {
        if(error.res){
            res.render('search',{booklist:null})
            console.log(error.res.data)
            console.log(error.res.status)
            console.log(error.res.headers)
        }else if(error.req){
            console.log(error.req)
        }else{
            // res.render('details',{bookDetails:null})
            console.log("error",error.message)

        }
    }
})


module.exports=newRouter

