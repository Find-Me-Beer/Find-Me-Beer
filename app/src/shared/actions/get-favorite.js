
import {httpConfig} from "../misc/http-config";

// export const getFavoriteByFavoriteBeerIdAndFavoriteUserId = (favoriteBeerId, favoriteUserId) => async dispatch => {
// 	const {data} = await httpConfig('/apis/favorite/?favoriteBeerId=${favoriteBeerId}&favoriteUserId=${favoriteUserId');
// 	dispatch({type: "GET_FAVORITE_BY_FAVORITE_BEER_ID_AND_FAVORITE_USER_ID", payload: data })
// };
//
// export const getFavoriteByFavoriteUserId = (favoriteUserId) => async dispatch => {
// 	const {data} = await httpConfig('/apis/favorite/?favoriteUserId=${favoriteUserId}');
// 	dispatch({type: "GET_FAVORITE_BY_FAVORITE_USER_ID", payload: data })
// };

export const getAllFavorites = () => async dispatch => {
	const {data} = await httpConfig('/apis/favorite/');
	dispatch({type: "GET_ALL_FAVORITES", payload: data })
};