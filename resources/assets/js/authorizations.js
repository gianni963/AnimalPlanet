let user = window.pettube.user;

module.exports = { 

	owns (model, prop = 'user_id') {
		return model[prop] === user.id;
	},

	isAdmin() {
		return ['gianni'].includes(user.name);
	}

};