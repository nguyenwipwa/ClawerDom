var http = require('http');
var fs = require('fs');

var mysql = require('mysql');
var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'shoplaptop'
});

var download = require('download-file');
connection.connect();
var url = require("url");
var path = require("path");
connection.query('SELECT * from product LIMIT 41, 50', function (error, results, fields) {
  if (error) throw error;
  // console.log('The solution is: ', results);
  results.forEach((e, i) => {
    var soureFile = e.img;
    var url_data = "http://laptopprocom.vn/" + e.img;
    var parsed = url.parse(url_data);
    // createFile(soureFile, url_data);
    setTimeout(function () {
      dowload_file(url_data, path.basename(parsed.pathname));
    }, 2000);
    // console.log(path.basename(parsed.pathname));
    // console.log('====================================')
    // console.log(e.img.indexOf("/"));
    // console.log('====================================')
  });
});

connection.end();
async function createFile(soureFile, urlFile) {
  var file = fs.createWriteStream(soureFile);
  var request = http.get(urlFile, function (response) {
    response.pipe(file);
  });
}
function dowload_file(url, basename) {

  // var url = "http://i.imgur.com/G9bDaPH.jpg"

  var options = {
    directory: "./upload/product/",
    filename: basename
  }
  download(url, options, function (err) {
    if (err) console.log("loi:----------------" + url);
    console.log(url);
  });
}