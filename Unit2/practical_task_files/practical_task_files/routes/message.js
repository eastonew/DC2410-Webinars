const express = require('express');
const status  = require('http-status');

module.exports = function(messages){
    var router = express.Router();
  
    router.get('/',function(req,res){
      messages.readAll(function(err,docs){
        res.send(docs);
      });
    });

    router.get('/:id',function(req,res){
        messages.read(req.params.id, function(err, doc){
            if(err) return res.sendStatus(status.BAD_REQUEST);
            if(doc) return res.send(doc);
            else    return res.sendStatus(status.NOT_FOUND);
        });
      });
      return router;
    }