import {combineReducers} from "redux"
import {beerReducer} from "./beerReducer";
import {favoriteReducer} from "./favoriteReducer"
import {breweryReducer} from "./breweryReducer";
import {userReducer} from "./userReducer";

export const combinedReducers = combineReducers({
	beer: beerReducer,
	breweries: breweryReducer,
	favorites: favoriteReducer,
	users: userReducer
});