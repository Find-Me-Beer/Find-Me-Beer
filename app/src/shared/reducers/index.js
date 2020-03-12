import {combineReducers} from "redux"
import beerReducer from "./beerReducer";
import favoriteReducer from "./favoriteReducer"

export const reducers = combineReducers({
	beer: beerReducer,
	favorites: favoriteReducer,
});