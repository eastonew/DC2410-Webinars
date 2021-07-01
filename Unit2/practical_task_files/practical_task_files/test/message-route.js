const bodyParser = require('body-parser');
const chai       = require('chai');
const expect     = chai.expect;
const request = require('superagent');
const status  = require('http-status');
const express = require('express');

const config = {
    port: 3000,
    db: {
      url:'mongodb://localhost:27017/test'
    }
  };
  
  const endpoint = '/api/v1/messages/';
  const apiRoot = 'http://localhost:' + config.port + endpoint;

  describe('api/v1/messages/ endpoint', function() {
    var server;
    var messages;
    const validMessages = [
      {
        username:'Alice',
        text:'Alice\'s Message'
      },
      {
        username:'Bob',
        text:'Bob\'s Message'
      }
    ];

    //Connect the messages library to MongoDB...
  before(function(done){
    messages = require('../lib/messages.js')(
      config.db.url,
      function(err){
        if(err) return done(new Error(err));
       
        var app = express();
        
        app.use(bodyParser.json());
        //...then pass it to the web API
        const router = require('../routes/message');
        app.use(endpoint,router(messages));
        server = app.listen(config.port,function(){
            done();
        });
      }
    );
  });

  //Ensure that all messages are removed from the database before each test to
  //prevent the result of one test affecting the next.
  beforeEach(function(done){
    messages.deleteAll(function(err){
      if(err) return done(new Error(err));
      done();
    });
  });

  //Disconnect the messages library from the DB and close the server after
  //running all tests.
  after(function(){
    messages.disconnect();
    server.close();
  });

    it('GET request to messages/:id gets message with specific ID', function(done){
        const INDEX = 0;
        messages.create(validMessages[INDEX], function(err, res){
            expect(err).to.be.null;
            expect(res).to.have.property('_id');
            request.get(apiRoot + res._id)
            .end(function(err, res){
                expect(err).to.be.null;
                expect(res.statusCode).to.equal(status.OK);
                expect(res.body).to.have.property('username');
                expect(res.body.username).to.equal(validMessages[INDEX].username);

                expect(res.body).to.have.property('text');
                expect(res.body.text).to.equal(validMessages[INDEX].text);
                done();
            });
        });
    });

    it('GET request to messages/:id fails with status NOT FOUND if the ID is ' +
    'not in the database', function(done){
        const INDEX = 0;
        messages.create(validMessages[INDEX], function(err, res){
            expect(err).to.be.null;
            expect(res).to.have.property('_id');
            const fakeId = '000000000000000000000000';
            request.get(apiRoot + fakeId)
            .end(function(err, res){
                expect(err).to.be.an('error');
                expect(res.statusCode).to.equal(status.NOT_FOUND);
                done();
            });
        });
    });

    it('GET request to messages/:id fails with status BAD REQUEST if the ID ' +
    'parameter is not convertible to an ID.', function(done){
        const INDEX = 0;
        messages.create(validMessages[INDEX],function(err,res){
            expect(err).to.be.null;
            expect(res).to.have.property('_id');
            const fakeId = "{$ne:''}";
            request.get(apiRoot + fakeId)
            .end(function(err, res){
                expect(err).to.be.an('error');
                expect(res.statusCode).to.equal(status.BAD_REQUEST);
                done();
            });
        });
    });

});