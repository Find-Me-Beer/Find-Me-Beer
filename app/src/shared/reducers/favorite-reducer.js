export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_FAVORITES":
			return action.payload;
		default:
			return state;
	}
}