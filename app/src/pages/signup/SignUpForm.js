import React, {useState} from 'react';
import {httpConfig} from "../../shared/misc/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignUpFormContent} from "./SignUpFormContent";
import {useHistory} from "react-router-dom";

export const SignUpForm = ({handleClose}) => {
	const history = useHistory();
	const signUp = {
		userAvatarUrl: "",
		userUsername: "",
		userEmail: "",
		userFirstName: "",
		userLastName: "",
		userDOB: "",
		userPassword: "",
		userPasswordConfirm: ""
	};


	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		userUsername: Yup.string()
			.required("user name is required"),
		userFirstName: Yup.string()
			.required("user's full name is required"),
		userLastName: Yup.string()
			.required("user's full name is required"),
		userDOB: Yup.string()
			.required("User must have a date of birth."),
		userPassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		userPasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
	});

	const submitSignUp = (values, {resetForm, setStatus}) => {
		httpConfig.post("./apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					if(reply.status === 200) {
						resetForm();
						handleClose();
						history.push("/sign-up-successful")
					} setStatus({message, type});
				}
			);
	};


	return (

		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>

	)
};