export function beerTagReducer (state = [], action) {
	switch(action.type) {
		case "GET_BEER_TAGS_BY_BEER_TAG_BEER_ID":
			return [...state, action.payload];
		case "GET_BEER_TAGS_BY_BEER_TAG_TAG_ID":
			return [...state, action.payload];
		default:
			return state
	}
}