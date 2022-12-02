import axios from "axios";
import { Enviroments } from "~/config";
const BASE_URL = axios.create({
    baseURL: Enviroments.BASE_API,
});

export { BASE_URL };
