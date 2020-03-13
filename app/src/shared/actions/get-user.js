import {httpConfig} from "../misc/http-config";

export const getUserByUserId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/user/${id}`);
	dispatch({type: "GET_USER_BY_USER_ID", payload: data })
};

export const getUserByUserEmail = (userEmail) => async dispatch => {
	const {data} = await httpConfig(`/apis/profile/?userEmail=${userEmail}`);
	dispatch({type: "GET_USER_BY_USER_ID", payload: data })
};