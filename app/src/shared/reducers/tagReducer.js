export function tagReducer (state = [], action) {
	switch(action.type) {
		case "GET_ALL_TAGS":
			return action.payload;
		case "GET_TAG_BY_TAG_ID":
			return [...state, action.payload];
		default:
			return state
	}
}