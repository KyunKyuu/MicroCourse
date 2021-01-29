'use strict';
const bcrypt = require('bcrypt');
module.exports = {
  up: async (queryInterface, Sequelize) => {
  
     await queryInterface.bulkInsert('users', [
     {
        name:"teguh",
        profession:"pelajar",
        role:"admin",
        email:"teguh.iqbal@gmail.com",
        password:await bcrypt.hash('rahasia123', 10),
        created_at: new Date(),
        updated_at: new Date()

     },
     {
        name:"iqbal",
        profession:"Data Engginer",
        role:"student",
        email:"iqbal.teguh@gmail.com",
        password:await bcrypt.hash('rahasia123', 10),
        created_at: new Date(),
        updated_at: new Date()
     }
     ]);
    
  },

  down: async (queryInterface, Sequelize) => {
  
      await queryInterface.bulkDelete('users', null, {});
    
  }
};
