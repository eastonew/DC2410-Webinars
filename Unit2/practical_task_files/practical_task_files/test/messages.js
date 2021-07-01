const async      = require('async');
const chai       = require('chai');
const expect     = chai.expect;

var config = {
  db: {
    url:'mongodb://localhost:27017/test'
  }
};

describe('messages library', function() {
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

  function testEmpty(done){
    return function(){
      messages.readAll(function(err,res){
        expect(err).to.be.null;
        expect(res).to.be.an('array');
        expect(res).to.be.empty;

        done();
      });
    };
  }

  //Connect the messages library to the DB before running the test.
  before(function(done){
    messages = require('../lib/messages.js')(
      config.db.url,
      function(err){
        if(err) return done(new Error(err));
        done();
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

  //Disconnect the messages library from the DB after running all tests.
  after(function(){
    messages.disconnect();
  });

  /* 1.2 Simple create and read*/
  it('messages.create() can create a message given data with username and ' +
     'text properties. It returns a copy of the message with matching username'+
     ' and text properties and an _id property.',function(done){
    const MESSAGE_IDX = 0;
    messages.create(validMessages[MESSAGE_IDX],function(err,res){
      expect(err).to.be.null;
      expect(res).to.be.an('object');

      expect(res).to.have.property('username');
      expect(res.username).to.equal(validMessages[MESSAGE_IDX].username);

      expect(res).to.have.property('text');
      expect(res.text).to.equal(validMessages[MESSAGE_IDX].text);

      expect(res).to.have.property('_id');
      done();
    });
  });

  //Test 1
  it('messages.read() reads a single message created by messages.create() ' +
     'using the _id property returned by the latter.',function(done){
    const MESSAGE_IDX = 0;
       messages.create(validMessages[MESSAGE_IDX],function(err,res){
         expect(res).to.be.an('object');
         expect(res).to.have.property('_id');
         messages.read(res._id,function(err,res){
           expect(err).to.be.null;

           expect(res).to.have.property('username');
           expect(res.username).to.equal(validMessages[MESSAGE_IDX].username);

           expect(res).to.have.property('text');
           expect(res.text).to.equal(validMessages[MESSAGE_IDX].text);

           done();
         });
       });
   });

   //Test 2
   it('messages.read() returns a null result given a non-existent ID',
    function(done){
    const MESSAGE_IDX = 0;
    messages.create(validMessages[MESSAGE_IDX],function(){
      const fakeId = '000000000000000000000000';
      messages.read(fakeId,function(err,res){
        expect(err).to.be.null;
        expect(res).to.be.null;
        done();
      });
    });
  });

   //Test 3
    it('messages.read() fails if given data which is not convertible to an ID',function(done){
    const MESSAGE_IDX = 0;
    messages.create(validMessages[MESSAGE_IDX],function(){
      const invalidId = {$ne:''};
      messages.read(invalidId,function(err,res){
        expect(err).to.not.be.null;
        expect(res).to.not.be.an('object');
        done();
      });
    });
  });
});
