export function userReducer (state = [], action) {
	switch(action.type) {
		case "GET_USER_BY_USER_ID":
			return [...state, action.payload];
		case "GET_USER_BY_USER_EMAIL":
			return [...state, action.payload];
		default:
			return state;
	}
}