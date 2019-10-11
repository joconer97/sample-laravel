import { setAuthorization } from './general'

export function login (credentials) {
  return new Promise((res, rej) => {
    axios.post('/api/auth/login', credentials)
      .then((response) => {
        setAuthorization(response.data.access_token)
        res(response.data)
      })
      .catch((error) => {
        rej('Wrong email or password')
      })
  })
}
export function getLocalUser () {
  const userString = localStorage.getItem('user')

  if (!userString)
    return null

  return JSON.parse(userString)
}
