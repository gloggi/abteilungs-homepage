import { mapKeys, isPlainObject, snakeCase, camelCase } from "lodash";
export const snakeToCamelObject = (obj) => {
	if (isPlainObject(obj)) {
		const newObject = mapKeys(obj, (_, key) => camelCase(key));
		Object.keys(newObject).forEach((key) => {
			newObject[key] = snakeToCamelObject(newObject[key]);
		});
		return newObject;
	} else if (Array.isArray(obj)) {
		return obj.map((element) => snakeToCamelObject(element));
	}
	return obj;
};

export const camelToSnakeObject = (obj) => {
	if (isPlainObject(obj)) {
		const newObject = mapKeys(obj, (_, key) => snakeCase(key));
		Object.keys(newObject).forEach((key) => {
			newObject[key] = camelToSnakeObject(newObject[key]);
		});
		return newObject;
	} else if (Array.isArray(obj)) {
		return obj.map((element) => camelToSnakeObject(element));
	}
	return obj;
};
