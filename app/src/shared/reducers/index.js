import {combineReducers} from "redux"
import {beerReducer} from "./beerReducer";
import {favoriteReducer} from "./favoriteReducer"
import {breweryReducer} from "./breweryReducer";

export const combinedReducers = combineReducers({
	beer: beerReducer,
	breweries: breweryReducer,
	favorites: favoriteReducer,

});