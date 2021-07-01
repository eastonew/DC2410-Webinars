const bodyParser = require('body-parser');
const chai       = require('chai');
const expect     = chai.expect;
const request = require('superagent');
const status  = require('http-status');

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
        const express = require('express');
        var app = express();
        app.use(json());
        //...then pass it to the web API
        app.use(endpoint,require('../routes/messages')(messages));
        server = app.listen(config.port,function(){done();});
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

  it('GET request to messages/ gets all messages',function(done){
    const MESSAGE_1_IDX = 0;
    const MESSAGE_2_IDX = 1;
    messages.create(validMessages[MESSAGE_1_IDX],function(){
      messages.create(validMessages[MESSAGE_2_IDX],function(){
        request.get(apiRoot)
          .end(function(err,res){
            expect(err).to.be.null;
            expect(res.statusCode).to.equal(status.OK);

            expect(res.body).to.be.an('array');
            expect(res.body.length).to.equal(2);

            const expectedNames = [validMessages[MESSAGE_1_IDX].username,
                                   validMessages[MESSAGE_2_IDX].username];
            const expectedTexts=  [validMessages[MESSAGE_1_IDX].text,
                                   validMessages[MESSAGE_2_IDX].text];
            const names = res.body.map((m)=>m.username);
            const texts = res.body.map((m)=>m.text);

            expect(names).to.have.members(expectedNames);
            expect(texts).to.have.members(expectedTexts);

            done();
          });
      });
    });
  });

  //Test 1
  it('GET request to messages/:id gets message with specific ID',
     function(done){
       const MESSAGE_IDX = 0;
       messages.create(validMessages[MESSAGE_IDX],function(err,res){
         expect(err).to.be.null;
         expect(res).to.have.property('_id');
         request.get(apiRoot + res._id)
           .end(function(err,res){
             expect(err).to.be.null;
             expect(res.statusCode).to.equal(status.OK);

             expect(res.body).to.have.property('username');
             expect(res.body.username).to.equal(validMessages[MESSAGE_IDX].username);

             expect(res.body).to.have.property('text');
             expect(res.body.text).to.equal(validMessages[MESSAGE_IDX].text);

             done();
           });
       });
     });

  //Test 2
  it('GET request to messages/:id fails with status NOT FOUND if the ID is ' +
     'not in the database', function(done){
      messages.create(validMessages[MESSAGE_IDX],function(err,res){
        expect(err).to.be.null;
        expect(res).to.have.property('_id');
       const fakeId = '000000000000000000000000';
       request.get(apiRoot + fakeId)
         .end(function(err,res){
           expect(err).to.be.an('error');
           expect(res.statusCode).to.equal(status.NOT_FOUND);
           done();
         });
        });
     });

  //Test 3
  it('GET request to messages/:id fails with status BAD REQUEST if the ID ' +
     'parameter is not convertible to an ID.', function(done){
      messages.create(validMessages[MESSAGE_IDX],function(err,res){
        expect(err).to.be.null;
        expect(res).to.have.property('_id');
       const invalidId = "{$ne:''}";
       request.get(apiRoot + invalidId)
         .end(function(err,res){
           expect(err).to.be.an('error');
           expect(res.statusCode).to.equal(status.BAD_REQUEST);
           done();
         });
        });
     });

    it('POST request with username and text creates a new message',
       function(done){
         const MESSAGE_IDX = 0;
         request.post(apiRoot)
           .send(validMessages[MESSAGE_IDX])
           .end(function(err,res){
           expect(err).to.be.null;
           expect(res.statusCode).to.equal(status.CREATED);

           expect(res.body).to.have.property('username');
           expect(res.body.username).to.equal(validMessages[MESSAGE_IDX].username);

           expect(res.body).to.have.property('text');
           expect(res.body.text).to.equal(validMessages[MESSAGE_IDX].text);

           expect(res.body).to.have.property('_id');

           messages.read(res.body._id,function(err,res){
             expect(err).to.be.null;

             expect(res).to.have.property('username');
             expect(res.username).to.equal(validMessages[MESSAGE_IDX].username);

             expect(res).to.have.property('text');
             expect(res.text).to.equal(validMessages[MESSAGE_IDX].text);

             done();
           });
         });
       });
});
