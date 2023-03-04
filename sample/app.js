const express=require('express')
// make sure the nodemon is install if the port is not running please use the following commond on terminal to run
// npm install nodemon --save
// here you can specifiy the  port for the PHP also..
const app=express()
// here we are using body parser to extract the heder value when we are movind from one page to another
//  here I am using this because when I m moving from the bookDetail page to single book details i need id to render that particular product
const bodyParser=require('body-parser')
const jquery=require('jquery')
port=5000
// so now we are going to add the static file paths so that our css or any other file donot lost there dir 
app.use(express.static('styles'))
app.use('/css',express.static(__dirname +'sample/styles/bookList.css'))
app.use('/js',express.static(__dirname +'sample/styles/bookList.css'))
// now we are going to create the templete engine for ejs 
app.set('views','./src/views')
app.set('view engine','ejs')
app.use(bodyParser.urlencoded({extended:true}))
// setting the routes
const newRouter=require('./src/routes/bookList')
app.use('/',newRouter)
app.use('/details',newRouter)
app.listen(port,()=>console.log(`running on ${port}`))