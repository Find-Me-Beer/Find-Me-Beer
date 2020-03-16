export function breweryReducer (state = [], action) {
	switch(action.type) {
		case "GET_ALL_BREWERIES":
			return action.payload;
		case "GET_BREWERY_BY_BREWERY_ID":
			return [...state, action.payload];
		case "GET_BREWERY_BY_LOCATION":
			return [...state, action.payload];
		case "GET_BREWERY_BY_BREWERY_NAME":
			return [...state, action.payload];
		default:
			return state
	}
}