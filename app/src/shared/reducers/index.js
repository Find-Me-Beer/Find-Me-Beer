
import {combineReducers} from "redux"
import {beerReducer} from "./beerReducer";
import {favoriteReducer} from "./favoriteReducer"
import {breweryReducer} from "./breweryReducer";
import {userReducer} from "./userReducer";
import {tagReducer} from "./tagReducer";
import {beerTagReducer} from "./beerTagReducer";

export const combinedReducers = combineReducers({
	beer: beerReducer,
	breweries: breweryReducer,
	favorites: favoriteReducer,
	users: userReducer,
	tags: tagReducer,
	beerTags: beerTagReducer
});
