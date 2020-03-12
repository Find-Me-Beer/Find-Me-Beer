export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_BEER":
			return action.payload;
		case "GET_BEER_BY_BEER_ID":
			return [...state, action.payload];
		default:
			return state
	}
}