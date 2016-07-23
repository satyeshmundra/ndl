import org.w3c.dom.*;
import javax.xml.parsers.*;
import java.io.*;
import java.util.ArrayList;

class ddcwrite
{
	static File fxmlFile = new File("ddcE.xml");

	public static void main(String args[])
	{
		try
		{	
			Element element;
			String s, s1;
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();

			Document doc = builder.parse(fxmlFile);

			NodeList nlist = doc.getElementsByTagName("node");

			PrintWriter pw = new PrintWriter(new File("DDC.csv"));
	        StringBuilder sb = new StringBuilder();

	        for (int i = 0; i < nlist.getLength() ; i++)
	        {
	        	element = (Element)nlist.item(i);
	        	s = element.getAttribute("label");
	        	//if(s.contains(","))
	        	s = "\"" + s + "\"";
	        	if(s.length() > 5)
	        		s1 = s.substring(0, 4) + "::" + s.substring(5);
	        	else
	        		s1 = s;
	        	sb.append(s1);
	        	sb.append('\n');
	        }
	    
	        pw.write(sb.toString());
	        pw.close();
		}
		catch(Exception e)
		{
			e.printStackTrace();
		}

	}

}