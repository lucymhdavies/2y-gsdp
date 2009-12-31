// The login class
// @author=Lucy Davies

public class Login
{
	static String[] FakeUsers = { "RDC", "RDS", "STC", "STS", "OM", "IT" };
	static String[] FakePasswords = { "password", "password", "password", "password", "password", "password" };
	static String[] FakeRoles = { "RDC", "RDS", "STC", "STS", "OM", "IT" };
	
	public static String login( String username, String password )
		throws InvalidUsernamePasswordException
	{
		for ( int i = 0 ; i < FakeUsers.length ; i++ )
		{
			if ( FakeUsers[i].toUpperCase() == username.toUpperCase() )
			{
				if ( FakePasswords[i] == password )
				{
					return FakeRoles[i];
				}
				else
				{
					throw new InvalidUsernamePasswordException();
				}
			}
		}
		throw new InvalidUsernamePasswordException();
	}
}

class InvalidUsernamePasswordException extends Exception
{
	public String toString()
	{
		return "Username/Password combination was invalid";
	}
}
