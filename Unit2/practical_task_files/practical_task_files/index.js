const express = require('express');

const config = {
  port: 3000,
  db: {
    url:'mongodb://localhost:27017/test'
  }
};

var messages = require('./lib/messages')(
  config.db.url,
  function(err){
    if(err) new Error(err);
    var app = express();
    app.use('/api/v1/messages/',require('./routes/messages')(messages));
    app.listen(config.port,function(){
      console.log('Listening on port ' + config.port);
    });
  }
);
