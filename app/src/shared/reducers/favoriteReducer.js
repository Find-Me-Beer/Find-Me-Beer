export function favoriteReducer (state = [], action) {
	switch(action.type) {
		case "GET_FAVORITE_BY_FAVORITE_BEER_ID_AND_FAVORITE_USER_ID":
			return [...state, action.payload];
		case "GET_FAVORITE_BY_FAVORITE_USER_ID":
			return [...state, action.payload];
		default:
			return state
	}
}