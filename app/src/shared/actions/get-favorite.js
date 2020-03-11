
import {httpConfig} from "../misc/http-config";

export const getAllFavorites = () => async dispatch => {
	const {data} = await httpConfig('/apis/favorite/');
	dispatch({type: "GET_ALL_FAVORITES", payload: data })
};