export function beerReducer (state = [], action) {
	switch(action.type) {
		case "GET_ALL_BEER":
			return action.payload;
		case "GET_BEER_BY_BEER_ID":
			return [...state, action.payload];
		case "GET_BEER_BY_BEER_BREWERY_ID":
			return [...state, action.payload];
		case "GET_BEER_BY_BEER_TYPE":
			return [...state, action.payload];
		case "GET_BEER_BY_BEER_TAG_ID":
			return [...state, action.payload];
		default:
			return state
	}
}