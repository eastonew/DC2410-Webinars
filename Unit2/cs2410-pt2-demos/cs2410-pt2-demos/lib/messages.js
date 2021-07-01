const sanitizeHTML = require('sanitize-html');
const mongoose = require('mongoose');
mongoose.set('useNewUrlParser', true);
mongoose.set('useUnifiedTopology', true);
mongoose.set('useFindAndModify', false);

const messageSchema = new mongoose.Schema(
  {
    username:{
      type:String,
      required:true
    },
    text:{
      type:String,
      required:true
    }
  },
  {strict:'throw'}
);
const Message = mongoose.model(
  'messages',
  messageSchema
);

module.exports = function(url,callback){
  mongoose.connect(url,callback);

  return {
    create:function(newMessage,callback){
      try {
        var message = new Message(newMessage);
      } catch(exception) {
        return callback('Unable to create Message');
      }
      if(message.username)
        message.username = sanitizeHTML(message.username);
      if(message.text)
        message.text     = sanitizeHTML(message.text);
      message.save(callback);
    },
    read:function(id,callback){
      Message.findById(id,callback);
    },
    readUsername:function(username,callback){
      if(typeof username !== 'string')
        return callback('Unable to parse username.');
      Message.find({username:username},callback);
    },
    readAll:function(callback){
      Message.find({},callback);
    },
    update:function(id,updatedMessage,callback){
      Message.findByIdAndUpdate(id,updatedMessage,callback);
    },
    delete:function(id,callback){
      Message.findByIdAndRemove(id,callback);
    },
    deleteAll:function(callback){
      Message.deleteMany({},callback);
    },
    disconnect:function(){
      mongoose.disconnect();
    }
  };
};
